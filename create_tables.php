<?php

    $amount_to_insert = 1000;

    $db_connection = pg_connect("host=localhost dbname=fridge_service user=postgres password=");

    //CREATE TABELS
            //APPOINTMENT
    pg_query($db_connection, "CREATE TABLE IF NOT EXISTS appointment (
                appointment_id integer NOT NULL,
                facility_id integer NOT NULL,
                appointment_type character(20),
                special_handling character(20),
                esimated_date date,
                real_date date NOT NULL,
                customer_id integer NOT NULL,
                appointment_data_to_export xml
            )");


                //customer

        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS customer (
                        customer_id integer NOT NULL,
                        fridge_id integer NOT NULL,
                        first_name character(50) NOT NULL,
                        last_name character(50) NOT NULL,
                        gender character(20) NOT NULL,
                        age integer NOT NULL,
                        title character(20),
                        phone character(100),
                        email character(100) NOT NULL,
                        password character(100) NOT NULL,
                        customer_to_export xml
                    )");

        // customer_address
        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS customer_address (
                    customer_id integer NOT NULL,
                    postal_code integer NOT NULL,
                    street character(100) NOT NULL,
                    hause integer NOT NULL,
                    flat integer NOT NULL,
                    porch integer NOT NULL
                )");

        //facility_rate

        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS facility_rate (
                appointment_id integer NOT NULL,
                rate double precision NOT NULL,
                rate_description character(150) NOT NULL,
                rate_type character(20) NOT NULL,
                recommend character(20) NOT NULL
            )");

        // fridge


        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS fridge (
                    fridge_id integer NOT NULL,
                    type character(20) NOT NULL,
                    year_of_prod date NOT NULL,
                    color character(20),
                    prod_country character(20),
                    volume double precision
                )");

        //local_facility
        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS local_facility (
                facility_id integer NOT NULL,
                postal_code integer NOT NULL,
                customer_id integer NOT NULL,
                local_facility_name character(50) NOT NULL,
                facility_type character(50) NOT NULL,
                facility_status character(10) NOT NULL
            )");

        // postal_code
        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS postal_code (
                postal_code integer NOT NULL,
                country character(20) NOT NULL,
                city character(20) NOT NULL,
                continent character(20) NOT NULL,
                type character(20) NOT NULL
            )");     

        //repair_status

        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS repair_status (
                appointment_id integer NOT NULL,
                status character(20),
                status_type character(20),
                repared character(20) NOT NULL,
                spendet_time time without time zone,
                esitmated_time time without time zone
            )");

        //symptom

        pg_query($db_connection, "CREATE TABLE IF NOT EXISTS symptom (
                appointment_id integer NOT NULL,
                symptom_type character(20) NOT NULL,
                symptom_description character(200) NOT NULL,
                caused_by character(20),
                assumption character(20),
                symptom_from date
            )");


    $query = "ALTER TABLE ONLY repair_status
    ADD CONSTRAINT appointment_id_pk PRIMARY KEY (appointment_id);";

    $query .= "ALTER TABLE ONLY appointment
    ADD CONSTRAINT appointment_pkey PRIMARY KEY (appointment_id);";
    $query .= "ALTER TABLE ONLY customer_address
    ADD CONSTRAINT customer_address_pkey PRIMARY KEY (customer_id);";
    $query .= "ALTER TABLE ONLY customer
    ADD CONSTRAINT customer_pkey PRIMARY KEY (customer_id);";
    $query .= "ALTER TABLE ONLY facility_rate
    ADD CONSTRAINT facility_rate_pkey PRIMARY KEY (appointment_id);";
    $query .= "ALTER TABLE ONLY fridge
    ADD CONSTRAINT fridge_pkey PRIMARY KEY (fridge_id);";
    $query .= "ALTER TABLE ONLY local_facility
    ADD CONSTRAINT local_facility_pkey PRIMARY KEY (facility_id);";
    $query .= "ALTER TABLE ONLY postal_code
    ADD CONSTRAINT postal_code_pkey PRIMARY KEY (postal_code);";
    $query .= "ALTER TABLE ONLY symptom
    ADD CONSTRAINT symptom_pkey PRIMARY KEY (appointment_id);";
    $query .= "ALTER TABLE ONLY facility_rate
    ADD CONSTRAINT appointment_id FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id);";
    $query .= "ALTER TABLE ONLY symptom
    ADD CONSTRAINT appointment_id FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id);";
    $query .= "ALTER TABLE ONLY repair_status
    ADD CONSTRAINT appointment_id FOREIGN KEY (appointment_id) REFERENCES appointment(appointment_id);";
    $query .= "ALTER TABLE ONLY customer_address
    ADD CONSTRAINT customer_id FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON UPDATE CASCADE ON DELETE CASCADE;";
    $query .= "ALTER TABLE ONLY local_facility
    ADD CONSTRAINT customer_id FOREIGN KEY (customer_id) REFERENCES customer(customer_id);";
    $query .= "ALTER TABLE ONLY appointment
    ADD CONSTRAINT customer_id FOREIGN KEY (customer_id) REFERENCES customer(customer_id);";
    $query .= "ALTER TABLE ONLY appointment
    ADD CONSTRAINT facility_id FOREIGN KEY (facility_id) REFERENCES local_facility(facility_id);";
    $query .= "ALTER TABLE ONLY customer
    ADD CONSTRAINT fridge_id FOREIGN KEY (fridge_id) REFERENCES fridge(fridge_id);";
    $query .= "ALTER TABLE ONLY customer_address
    ADD CONSTRAINT postal_code FOREIGN KEY (postal_code) REFERENCES postal_code(postal_code);";
    $query .= "ALTER TABLE ONLY local_facility
    ADD CONSTRAINT postal_code FOREIGN KEY (postal_code) REFERENCES postal_code(postal_code);";

pg_query($db_connection, $query);


?>