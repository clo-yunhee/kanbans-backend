#!/bin/bash

cd .. && vendor/bin/doctrine orm:schema-tool:drop --force \
      && vendor/bin/doctrine orm:schema-tool:update --force
