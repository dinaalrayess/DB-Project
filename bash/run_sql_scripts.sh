#!/usr/bin/env bash

read -p "Enter MySQL Host: " HOST
read -p "Enter MySQL Username: " USERNAME
read -sp "Enter MySQL Password: " PASSWORD
echo
read -p "Enter MySQL Port (default 3306): " PORT
PORT=${PORT:-3306}

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_FILE="$SCRIPT_DIR/../logs/MySQl_logs.log"
SQL_DIR="$SCRIPT_DIR/../sql"

# Attempt to connect to the MySQL server
echo "$PASSWORD" | mysql -h "$HOST" -u "$USERNAME" -P "$PORT" -e "exit"

execute_mysql() {
    local sql_file="$1"
    echo "Executing $(basename "$sql_file")..."
    {
        echo "$PASSWORD" | mysql -h "$HOST" -u "$USERNAME" -P "$PORT" < "$sql_file"
    } >> "$LOG_FILE" 2>&1

    if [ $? -eq 0 ]; then
        echo "SQL file executed successfully."
    else
        echo "Failed to execute SQL file."
    fi
}

# Check if the connection was successful
if [ $? -eq 0 ]; then
    echo "Connection successful!"

    touch $LOG_FILE

    echo "Creating database..."
    {
        echo "$PASSWORD"
        mysql -v -h "$HOST" -u "$USERNAME" -P "$PORT" < "$SQL_DIR/create_database.sql"
    } >> "$LOG_FILE" 2>&1

    # Creating database
    echo "Creating database..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/create_database.sql"

    # Creating tables
    echo "Creating tables..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/create_tables.sql"

    # Creating triggers
    echo "Creating triggers..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/create_triggers.sql"

    # Creating functions
    echo "Creating functions..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/create_functions.sql"

    # Creating procedures
    echo "Creating procedures..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/create_procedures.sql"

    # Creating views
    echo "Creating views..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/create_views.sql"

    # Inserting data
    echo "Inserting data..." >> "$LOG_FILE"
    execute_mysql "$SQL_DIR/insert_data.sql"
else
    echo "Connection failed. Please check your credentials and try again."
fi

