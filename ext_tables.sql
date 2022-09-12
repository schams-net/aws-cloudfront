-- Database schema

CREATE TABLE tx_awscloudfront_domain_model_invalidation (
    method varchar(255) DEFAULT '' NOT NULL,
    paths text DEFAULT '' NOT NULL
);
