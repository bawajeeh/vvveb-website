#!/bin/bash
# Render Deployment Automation Helper
# This script helps you extract database info and prepare for Render deployment

echo "=========================================="
echo "Render Deployment Helper"
echo "=========================================="
echo ""

# Function to extract database info from connection string
extract_db_info() {
    local conn_string="$1"
    
    # Parse postgresql://user:password@host:port/database
    if [[ $conn_string =~ postgresql://([^:]+):([^@]+)@([^:]+):([^/]+)/(.+) ]]; then
        DB_USER="${BASH_REMATCH[1]}"
        DB_PASSWORD="${BASH_REMATCH[2]}"
        DB_HOST="${BASH_REMATCH[3]}"
        DB_PORT="${BASH_REMATCH[4]}"
        DB_DATABASE="${BASH_REMATCH[5]}"
        
        echo "✅ Database info extracted:"
        echo "   Host: $DB_HOST"
        echo "   Port: $DB_PORT"
        echo "   Database: $DB_DATABASE"
        echo "   User: $DB_USER"
        echo "   Password: [hidden]"
        echo ""
        
        return 0
    else
        echo "❌ Invalid connection string format"
        return 1
    fi
}

echo "STEP 1: Database Connection String"
echo "-----------------------------------"
echo "After creating PostgreSQL database on Render, you'll get a connection string."
echo "It looks like: postgresql://user:password@host:5432/database"
echo ""
read -p "Paste your Internal Database URL here: " DB_CONN_STRING

if extract_db_info "$DB_CONN_STRING"; then
    echo ""
    echo "STEP 2: Environment Variables for Render"
    echo "-----------------------------------------"
    echo "Copy these EXACT values into Render Web Service Environment Variables:"
    echo ""
    echo "Key: PHP_VERSION"
    echo "Value: 8.1"
    echo ""
    echo "Key: DB_ENGINE"
    echo "Value: pgsql"
    echo ""
    echo "Key: DB_HOST"
    echo "Value: $DB_HOST"
    echo ""
    echo "Key: DB_PORT"
    echo "Value: $DB_PORT"
    echo ""
    echo "Key: DB_DATABASE"
    echo "Value: $DB_DATABASE"
    echo ""
    echo "Key: DB_USER"
    echo "Value: $DB_USER"
    echo ""
    echo "Key: DB_PASSWORD"
    echo "Value: $DB_PASSWORD"
    echo ""
    
    # Save to file
    cat > render-env-vars.txt <<EOF
PHP_VERSION=8.1
DB_ENGINE=pgsql
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_DATABASE=$DB_DATABASE
DB_USER=$DB_USER
DB_PASSWORD=$DB_PASSWORD
EOF
    
    echo "✅ Saved to: render-env-vars.txt"
    echo ""
    echo "STEP 3: Installation Database Credentials"
    echo "-----------------------------------------"
    echo "Use these when installing via web interface:"
    echo ""
    echo "Database Engine: PostgreSQL"
    echo "Host: $DB_HOST"
    echo "Port: $DB_PORT"
    echo "Database: $DB_DATABASE"
    echo "Username: $DB_USER"
    echo "Password: $DB_PASSWORD"
    echo ""
else
    echo "Please try again with a valid connection string."
fi

