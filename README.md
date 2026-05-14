# Encapsulation Workshop

A PHP workshop project demonstrating object-oriented encapsulation principles through a simple shopping system simulation.

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (macOS, Windows, or Linux)

## Running the project

```bash
make build   # build the Docker image
make run     # run the simulation
make shell   # open a shell inside the container
```

## What it does

Simulates a product supply chain: a **Manufacturer** supplies products to a **Shop**, which sells them to a **Customer**. The program prints a financial summary at the end showing capital and balances for each party.
