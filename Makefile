.PHONY: build run shell

build:
	docker compose build

run:
	docker compose run --rm app

shell:
	docker compose run --rm app bash
