CREATE TABLE category( 
      id number(10)    NOT NULL , 
      cod varchar  (50)    NOT NULL , 
      description varchar  (50)    NOT NULL , 
      presentation_text varchar(3000)   , 
      subject_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE lead( 
      id number(10)    NOT NULL , 
      name varchar  (255)    NOT NULL , 
      email varchar  (1024)   , 
      date_birth date   , 
      telephone varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE possible_answers( 
      id number(10)    NOT NULL , 
      questions_id number(10)    NOT NULL , 
      description varchar(3000)    NOT NULL , 
      answer_weight number(10)    DEFAULT 0 , 
      requires_obs number(10)    DEFAULT 0 , 
 PRIMARY KEY (id)) ; 

CREATE TABLE questions( 
      id number(10)    NOT NULL , 
      description varchar  (1024)    NOT NULL , 
      category_id number(10)    NOT NULL , 
      type_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE subject( 
      id number(10)    NOT NULL , 
      description varchar  (50)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document( 
      id number(10)    NOT NULL , 
      category_id number(10)    NOT NULL , 
      system_user_id number(10)   , 
      title varchar(3000)    NOT NULL , 
      description varchar(3000)   , 
      submission_date date   , 
      archive_date date   , 
      filename varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_category( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id number(10)    NOT NULL , 
      document_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_user( 
      id number(10)    NOT NULL , 
      document_id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_message( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_user_to_id number(10)    NOT NULL , 
      subject varchar(3000)    NOT NULL , 
      message varchar(3000)   , 
      dt_message timestamp(0)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_notification( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_user_to_id number(10)    NOT NULL , 
      subject varchar(3000)   , 
      message varchar(3000)   , 
      dt_message timestamp(0)   , 
      action_url varchar(3000)   , 
      action_label varchar(3000)   , 
      icon varchar(3000)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)    NOT NULL , 
      preference varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      controller varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      connection_name varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_group_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_program_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      login varchar(3000)    NOT NULL , 
      password varchar(3000)    NOT NULL , 
      email varchar(3000)   , 
      frontpage_id number(10)   , 
      system_unit_id number(10)   , 
      active char  (1)   , 
      accepted_term_policy_at varchar(3000)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
      system_unit_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE type( 
      id number(10)    NOT NULL , 
      description varchar  (50)    NOT NULL , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE category ADD CONSTRAINT fk_category_1 FOREIGN KEY (subject_id) references subject(id); 
ALTER TABLE possible_answers ADD CONSTRAINT fk_possible_answers_1 FOREIGN KEY (questions_id) references questions(id); 
ALTER TABLE questions ADD CONSTRAINT fk_questions_1 FOREIGN KEY (type_id) references type(id); 
ALTER TABLE questions ADD CONSTRAINT fk_questions_2 FOREIGN KEY (category_id) references category(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_2 FOREIGN KEY (category_id) references system_document_category(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
 CREATE SEQUENCE category_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER category_id_seq_tr 

BEFORE INSERT ON category FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT category_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE lead_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER lead_id_seq_tr 

BEFORE INSERT ON lead FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT lead_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE possible_answers_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER possible_answers_id_seq_tr 

BEFORE INSERT ON possible_answers FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT possible_answers_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE questions_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER questions_id_seq_tr 

BEFORE INSERT ON questions FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT questions_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE subject_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER subject_id_seq_tr 

BEFORE INSERT ON subject FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT subject_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE type_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER type_id_seq_tr 

BEFORE INSERT ON type FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT type_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 
  
