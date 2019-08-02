#!/bin/sh

envsubst < assets/runtime.js.template > assets/runtime.js
nginx -g "daemon off;"
