-- Create the database
CREATE DATABASE contact_form;

USE contact_form;

-- Create the contact table with columns for first name, last name, email, and messages
CREATE TABLE contact (
    id int(11) NOT NULL AUTO_INCREMENT,
    first_name varchar(254) NOT NULL,
    last_name varchar(254) NOT NULL,
    email varchar(254) NOT NULL,
    messages text,
    primary key (id)
);

-- Create the store suggestions table with columns for store name, store address, and time created
CREATE TABLE store_suggestions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    store_name VARCHAR(255) NOT NULL,
    store_address VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `random_stores` (
     id INT AUTO_INCREMENT PRIMARY KEY,
    store_name VARCHAR(255) NOT NULL,
    store_address VARCHAR(255) NOT NULL
);

INSERT INTO `random_stores` (store_name, store_address) VALUES
('The Salvation Army', '1244 Manheim Pike, Lancaster, PA 17601'),
('2nd Street', '1282 Third Ave, New York, NY 10021'),
('Thrifty Thrift', '3841 Oakton St, Skokie, IL 60076'),
('Goodwill NYNJ Bins', '47-47 Van Dam St, Long Island City, NY 11101');
