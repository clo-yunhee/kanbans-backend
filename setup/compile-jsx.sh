#!/bin/bash

cd .. && npx babel --watch src/jsx --out-dir js --presets react-app/prod
