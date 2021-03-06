<?php
namespace DBAL\Caching;

use Memcache;
use Exception;

/**
 * @codeCoverageIgnore
 */
class MemcacheCache implements CacheInterface{
    
    protected $cache;

    /**
     * MemcacheCache constructor
     */
    public function __construct(){
        if (!extension_loaded('memcache')) {
            throw new Exception('Memcache extension is not loaded');
        }
        $this->cache = new Memcache();
    }
    
    /**
     * MemcacheCache destructor closes the connection
     */
    public function __destruct(){
        if (is_object($this->cache)) {
            $this->cache->close();
        }
    }

    /**
     * Connect to a server
     * @param string $host This should be the host name or IP address you want to connect to
     * @param int $port The port number where Memcache can be accessed
     * @param boolean $persistent If you want this connection to be persistent set to true else set to false
     * @return $this
     */
    public function connect($host, $port, $persistent = false){
        if($persistent === false){
            $this->cache->connect($host, intval($port));
        }
        else{
            $this->cache->pconnect($host, intval($port));
        }
        return $this;
    }
    
    /**
     * Add a server to connection pool
     * @param string $host This should be the host name or IP address you want to add to the Memcache pool
     * @param int $port The port number where Memcache can be accessed
     * @param boolean $persistent If you want this connection to be persistent set to true else set to false
     * @return $this
     */
    public function addServer($host, $port, $persistent = true){
        $this->cache->addServer($host, intval($port), $persistent);
        return $this;
    }

    /**
     * Adds a value to be stored on the server
     * @param string $key This should be the key for the value you wish to add
     * @param mixed $value The value you wish to be stored with the given key
     * @param int $time How long should the value be stored for in seconds (0 = never expire) (max set value = 2592000 (30 Days))
     * @return boolean Returns true if successfully added or false on failure
     */
    public function save($key, $value, $time = 0){
        return $this->cache->add($key, $value, 0, intval($time));
    }
    
    /**
     * Replaces a stored value for a given key 
     * @param string $key This should be the key for the value you wish to replace
     * @param mixed $value The new value that you wish to give to that key
     * @param int $time How long should the value be stored for in seconds (0 = never expire) (max set value = 2592000 (30 Days))
     * @return boolean Returns true if successfully replaced or false on failure
     */
    public function replace($key, $value, $time = 0){
        return $this->cache->replace($key, $value, 0, intval($time));
    }
    
    /**
     * Returns the values store for the given key
     * @param string $key This should be the unique query key to get the value
     * @return mixed The store value will be returned
     */
    public function fetch($key){
        return $this->cache->get($key);
    }
    
    /**
     * Deletes a single value from the server based on the given key
     * @param string $key This should be the key that you wish to delete the value for
     * @return boolean Returns true on success or false on failure
     */
    public function delete($key){
        return $this->cache->delete($key);
    }
    
    /**
     * Deletes all values from the server
     * @return boolean Returns true on success or false on failure
     */
    public function deleteAll(){
        return $this->cache->flush();
    }
}
