#!/usr/bin/env bash
# Just needs npm/node for running
set -euo pipefail

npx --yes --package ajv@8.20.0 --package ajv-formats@3.0.1 node command/validate-json.mjs
