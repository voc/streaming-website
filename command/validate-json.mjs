#!/usr/bin/env node

import { createRequire } from "node:module";
import { execFileSync } from "node:child_process";
import { existsSync, readFileSync } from "node:fs";
import { glob } from "node:fs/promises";
import path from "node:path";
import process from "node:process";

const repoRoot = path.resolve(import.meta.dirname, "..");

// load library from npx cache environment
function loadPackages() {
  const candidates = process.env.PATH.split(path.delimiter)
    .filter((entry) => entry.endsWith(`${path.sep}node_modules${path.sep}.bin`))
    .map((entry) => path.dirname(entry));

  for (const nodeModulesPath of candidates) {
    if (
      !existsSync(
        path.join(nodeModulesPath, "json-schema-library", "package.json"),
      )
    ) {
      continue;
    }
    const requireFromNodeModules = createRequire(
      path.join(nodeModulesPath, "package.json"),
    );
    const jsonschemalib = requireFromNodeModules("json-schema-library");

    return {
      compileSchema: jsonschemalib.compileSchema,
      SchemaNode: jsonschemalib.SchemaNode,
    };
  }

  throw new Error(
    "Unable to resolve libraries from the current npx environment",
  );
}

const { compileSchema, SchemaNode } = loadPackages();

function readJson(file) {
  const content = readFileSync(file, "utf8");
  try {
    return JSON.parse(content);
  } catch (error) {
    const relpath = path.relative(repoRoot, file);
    const details = error instanceof Error ? error.message : String(error);
    throw new Error(`${relpath}: ${details}`);
  }
}

async function validateConferenceConfigs(globPattern) {
  const schemaPath = path.join(repoRoot, "docs/config-schema.json");
  const schema = compileSchema(readJson(schemaPath));

  const files = await glob(globPattern);
  for await (const file of files) {
    const data = readJson(file);
    const { valid, errors } = schema.validate(data);
    const relpath = path.relative(repoRoot, file);
    if (!valid) {
      const errorMessages = (errors ?? [])
        .map((error) => {
          const instancePath = error.instancePath || "/";
          return `${instancePath} ${error.message}`;
        })
        .join("\n");

      throw new Error(`${relpath}:\n${errorMessages}`);
    }

    console.log(`${relpath} valid`);
  }
}

try {
  await validateConferenceConfigs(
    path.join(repoRoot, "configs/conferences/**/config.json"),
  );
} catch (error) {
  console.error(error instanceof Error ? error.message : String(error));
  process.exit(1);
}
