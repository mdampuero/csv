#!/bin/bash
echo "################################################"
echo "##              Start containers              ##"
echo "################################################"
docker-compose -f docker/docker-compose.yaml up -d
echo "################################################"
echo "##     Running on http://localhost:8001/      ##"
echo "################################################"