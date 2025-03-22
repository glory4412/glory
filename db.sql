
CREATE TABLE next_of_kin_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_holder_name VARCHAR(255) NOT NULL,
    account_holder_email VARCHAR(255) NOT NULL,
    account_holder_phone VARCHAR(20) NOT NULL,
    account_holder_dob DATE NOT NULL,
    valid_id VARCHAR(255),
    nok_name VARCHAR(255) NOT NULL,
    nok_email VARCHAR(255),
    nok_phone VARCHAR(20) NOT NULL,
    nok_address TEXT NOT NULL,
    nok_relationship VARCHAR(100) NOT NULL,
    bank_name VARCHAR(255) NOT NULL,
    bank_account_number VARCHAR(50) NOT NULL,
    routing_number VARCHAR(50),
    user_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    signature VARCHAR(255) NOT NULL,
    submission_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
