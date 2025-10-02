CREATE TABLE /*_*/thumbfeedback (
    tf_id INT AUTO_INCREMENT PRIMARY KEY,
    tf_page_id INT NOT NULL,
    tf_user_id INT NULL,
    tf_vote SMALLINT NOT NULL,
    tf_comment TEXT,
    tf_timestamp BINARY(14) NOT NULL
);