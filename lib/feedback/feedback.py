#!/usr/bin/env python3
# Port of the ruby mqttfeedback client to python using asyncio and aiomqtt
# Sends feedback entries from the feedback sqlite database to an MQTT server
#
# Automatically restarts on script changes for easy deployment
import os
import json
import argparse
import sqlite3
import asyncio
import aiomqtt


async def main():
    file_path = os.path.realpath(__file__)
    last_modified = os.path.getmtime(file_path)
    restart = False

    args = parse_args()
    db = sqlite3.connect(args.file)
    db.row_factory = sqlite3.Row
    try:
        async with aiomqtt.Client(
            args.destination, username=args.user, password=args.password
        ) as client:
            print("Service started, waiting for feedback")
            while True:
                # Check whether our script file has changed on disk
                current_modified = os.path.getmtime(file_path)
                if current_modified != last_modified:
                    restart = True
                    break
                feedbacks = read_feedbacks(db)
                for feedback in feedbacks:
                    try:
                        await publish(client, "/voc/feedback", feedback, args.noop)
                        confirm_write(db, feedback["rowid"])
                        print(f"Pushed to irc: {for_humans(feedback)}")
                    except aiomqtt.MqttError as e:
                        print(f"Failed to publish feedback {feedback['rowid']}: {e}")
                    await asyncio.sleep(0.5)  # avoid flooding too fast
                if len(feedbacks) == 0:
                    await asyncio.sleep(5)
    except asyncio.CancelledError:
        pass
    db.close()
    print("Service stopped")
    if restart:
        print("Restarting Service")
        os.execv(file_path, [file_path] + os.sys.argv[1:])


# Read new feedback entries from the database.
def read_feedbacks(db: sqlite3.Connection) -> list[dict]:
    feedbacks = []
    for row in db.execute("SELECT rowid, * FROM feedback WHERE sent=0 LIMIT 20"):
        feedbacks.append({key: row[key] for key in row.keys()})
    return feedbacks


# Mark feedback entry as sent.
def confirm_write(db: sqlite3.Connection, rowid: int):
    with db:
        db.execute("UPDATE feedback SET sent=1 WHERE rowid=?", (rowid,))


# Send messages to MQTT server.
async def publish(client: aiomqtt.Client, path: str, feedback: dict, noop: bool):
    if noop:
        return
    await asyncio.gather(
        # for humanes
        client.publish("/voc/alert", json.dumps(for_humans(feedback))),
        # for machines
        client.publish(path, json.dumps(feedback)),
    )


# Convert event to human readable message.
def for_humans(feedback: dict) -> dict:
    msg = {}

    msg["component"] = "feedback/new"
    msg["level"] = "info"
    # use different messages for warning and info

    msg["msg"] = create_feedback_text(feedback)
    return msg


# Convert feedback dict to string
def create_feedback_text(feedback: dict) -> str:
    return f"{feedback['rowid']}: watching '{feedback['stream']}' using '{feedback['player']}' '{feedback['issuetext']}'"


def parse_args():
    parser = argparse.ArgumentParser(description="MQTT Feedback Service")
    parser.add_argument(
        "--file",
        "-f",
        type=str,
        default=os.environ.get("FEEDBACK_DATABASE"),
        help="database file (env FEEDBACK_DATABASE)",
    )
    parser.add_argument(
        "--user",
        "-u",
        type=str,
        default=os.environ.get("MQTT_USER"),
        help="mqtt user (env MQTT_USER)",
    )
    parser.add_argument(
        "--password",
        "-p",
        type=str,
        default=os.environ.get("MQTT_PASSWORD"),
        help="mqtt password (env MQTT_PASSWORD)",
    )
    parser.add_argument(
        "--destination",
        "-d",
        type=str,
        default=os.environ.get("MQTT_SERVER"),
        help="mqtt server (env MQTT_SERVER)",
    )
    parser.add_argument(
        "--noop",
        "-n",
        action="store_true",
        help="do not actually send messages, just print what would be sent",
    )
    args = parser.parse_args()
    if not args.file:
        parser.error("Database file must be specified via --file or FEEDBACK_DATABASE")
        exit(1)
    if not args.file or not args.user or not args.password or not args.destination:
        parser.print_help()
        exit(1)
    return args


if __name__ == "__main__":
    asyncio.run(main())
