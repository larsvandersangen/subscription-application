# Subscription application

Test application made with Symfony, API platform and GraphQL.
Install and initialise the database with: 

```bash 
$ composer install
$ ./bin/console doctrine:migrations:migrate
```

## 1. & 2. Check requirements:

Check the requirements with the following command:
```bash 
$ ./bin/console about
```


## 3. Validate database connection with doctrine/migrations

Validate that there is a database connection with:

```bash
$ ./bin/console doctrine:migrations:status
```

Further check the `src/Entity` folder to validate any Entity relation structure.

## 4. Fixtures

At this moment there is 1 fixture in `src/DataFixtures` named `AppFixtures`. 
In this fixture the database is seeded for all the entities in the application.

With more time I will reconfigure this to map it to seperate fixtures.


## 5. API-platform
Check the composer.json for the used versions of API-platform.



## 6. GraphQL endpoints:

### 6.1 Ask collection of all subscriptions
```graphql
{
  customSubscriptionEndpointSubscriptions {
    edges {
      node {
        id
        firstname
        lastname
        user {
          paymentInfo {
            iban
          }
        }
        email {
          email
        }
        address {
          street
          housenumber
          postalcode
        }
      }
    }
  }
}

```


### 6.2 Ask specific subscription per ID
```graphql
customSubscriptionItemEndpointSubscription(id: "/api/subscriptions/XXXX") 
{
  id
  firstname
}
```





### 6.3 Mutation on email for subscription
TBD



### 6.4 Create new subscription
TBD



