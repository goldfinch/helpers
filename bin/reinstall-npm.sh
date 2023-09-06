#!/bin/bash

# npm cache clean --force
rm -rf node_modules/
rm -rf package-lock.json
npm install
npm run build
