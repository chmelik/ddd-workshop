# DDD & hexagonal architecture

- Core domain
- Supporting subdomain
- Generic subdomain


## Bounded context
![](https://i.stack.imgur.com/1T643l.png)
![](https://i.stack.imgur.com/S3KV7l.png)
![](https://martinfowler.com/bliki/images/boundedContext/sketch.png)


## Ubiquitous Language


## Layers
1. Domain layer
   - Domain model
   - Repository Interface
   - Domain Services Interface
2. Application
3. Infrastructure

![DDD layers](https://i.stack.imgur.com/6cJym.png)
![DDD Hexagonal](https://i.stack.imgur.com/gPKrg.jpg)

!!! begin
![!!!](https://miro.medium.com/v2/resize:fit:4800/format:webp/1*tlDMaDq31GpV__O1O6DGCA.png)
![!!!](https://miro.medium.com/v2/resize:fit:4800/0*7KIbDkcEtdHfsfY8)
!!! end


## Domain elements
- Entity
- Value Object
- Aggregate*
- Aggregate Root


## Anemic Domain Model


## Application
- Command
- Query
- CQS

## Domain Events



---

docker-compose run --no-deps app_php vendor/bin/deptrac analyze --fail-on-uncovered --report-uncovered --no-progress --cache-file .deptrac_hexa.cache --config-file deptrac_hexa.yaml
docker-compose run --no-deps app_php vendor/bin/deptrac analyze --fail-on-uncovered --report-uncovered --no-progress --cache-file .deptrac_bc.cache --config-file deptrac_bc.yaml
