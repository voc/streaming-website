#!/usr/bin/env bash
# Just needs npm/node for running
set -euo pipefail

npx --yes --package json-schema-library@11.6.1 node command/validate-json.mjs
