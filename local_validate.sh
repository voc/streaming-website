#!/usr/bin/env bash
# Before this, run `npm i -g ajv-cli ajv-formats`

ajv validate -s docs/config-schema.json -c ajv-formats -d "configs/conferences/**/config.json"
