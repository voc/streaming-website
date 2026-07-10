#!/usr/bin/env node

import { createRequire } from "node:module";
import { execFileSync } from "node:child_process";
import { existsSync, readFileSync } from "node:fs";
import { glob } from "node:fs/promises";
import path from "node:path";
import process from "node:process";

const repoRoot = path.resolve(import.meta.dirname, "..");

// load ajv and ajv-formats from npx cache environment
function loadAjvPackages() {
  const candidates = process.env.PATH.split(path.delimiter)
    .filter((entry) => entry.endsWith(`${path.sep}node_modules${path.sep}.bin`))
    .map((entry) => path.dirname(entry));

  for (const nodeModulesPath of candidates) {
    if (!existsSync(path.join(nodeModulesPath, "ajv", "package.json"))) {
      continue;
    }

    const requireFromNodeModules = createRequire(
      path.join(nodeModulesPath, "package.json"),
    );
    const ajvModule = requireFromNodeModules("ajv");
    const ajvFormatsModule = requireFromNodeModules("ajv-formats");

    return {
      Ajv: ajvModule.default ?? ajvModule,
      addFormats: ajvFormatsModule.default ?? ajvFormatsModule,
    };
  }

  throw new Error("Unable to resolve ajv from the current npx environment");
}

const { Ajv, addFormats } = loadAjvPackages();

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
  const schemaPath = "docs/config-schema.json";
  const schema = readJson(schemaPath);
  const ajv = new Ajv({ allErrors: true, strict: false });

  addFormats(ajv);

  const validate = ajv.compile(schema);

  const files = await glob(globPattern);
  for await (const file of files) {
    const relpath = path.relative(repoRoot, file);
    const data = readJson(file);
    const valid = validate(data);

    if (!valid) {
      const errors = (validate.errors ?? [])
        .map((error) => {
          const instancePath = error.instancePath || "/";
          return `${instancePath} ${error.message}`;
        })
        .join("\n");

      throw new Error(`${relpath}:\n${errors}`);
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
