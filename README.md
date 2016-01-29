# minimal-db
A lightweight, minimalistic database class for PHP. Aimed to give you pure database functionality and nothing else. The aim it to create an extenable, lightweight framework to allow you easy access to databases.

This framework consists of 3 parts:

## Database Class

This class will handle the direct interaction with the database, executing queries.

## Query Class

This class generate any of four queries: Select, Insert, Delete, and Update.

##  Table Adapter Class
This class gets linked to one table in the database. This function then gets used to create connections to the table and extract data.

## Using the framework
Using the framework is very simple. For each table you would like to access in your database create a sub class of the TableAdapter class. The use the queries as follows:

### SELECT

    $tableAdapter = new tableAdapter( 'users' ); //  Or your custom class $tableAdapter = new UsersTable( 'users' );

    $where = array(
        'id' => 3,
        'username' => 'John'
    );

    $tableAdapter->select( $where );
    $row = $tableAdapter->currentRow();

### INSERT
    
    //  Works with column => value pairs
    $tableAdapter = new tableAdapter( 'users' ); // Or your custom table.
    
    $data = array(
        'username' => 'john',
        'first_name' => 'John',
        'last_name' => 'Doe',
    );
    
    $insertID = $tableAdapter->insert( $data );

### DELETE

    //  Delete works exactly like insert, except that your data is
    //  where you would like to delete
    $tableAdapter = new tableAdapter( 'users' ); // Or your custom table.
        
    $where = array(
        'username' => 'john',
        'first_name' => 'John',
    );
        
    $tableAdapter->delete( $where );
    
### UPDATE

    //  Update works in a similar way.
    $updateData = array(
        'first_name' => 'Jane',
        'last_name' => 'Doe',
    );
    
    $where = array(
        'username' => 'john',
    );
    
    $tableAdapter = new tableAdapter( 'users' ); // Or your custom table.
    
    $tableAdapter->update( $updateData, $where );