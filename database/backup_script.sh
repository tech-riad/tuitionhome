TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
DB_USER="tuitiont_terminal"
DB_PASSWORD="X4XnZ1iW3Q"
DB_NAME="tuitiont_tuition_terminal"
BACKUP_DIR="/test.tuitionterminal.com.bd/database"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Backup the database
mysqldump -u$DB_USER -p$DB_PASSWORD $DB_NAME > $BACKUP_DIR/$DB_NAME_$TIMESTAMP.sql

# Optionally compress the backup file
gzip $BACKUP_DIR/$DB_NAME_$TIMESTAMP.sql