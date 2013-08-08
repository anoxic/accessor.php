<?php
/**
 * A generic accessor.
 * 
 * Takes some ideas from ruby here, allowing you to set up variables that are readable, writable, or both (accessable).
 * Comes with these helpers: all(), and set()
 * The default contructor takes an array and tries to set each value.
 * That's it!
 */
class Accessor
{
    protected $_data = array();
    protected $_readable = array();
    protected $_writable = array();
    protected $_accessable = array();
    protected $_joined = false;

    public function __construct(array $ary = array())
    {
        return $this->set($ary);
    }

    final function __set($name, $value)
    {
        $this->__join();
        $name = strtolower($name);
        
        if (!in_array($name, $this->_writable)) {
            throw new OutOfRangeException('Cannot set property ' . get_class($this) . '::$' . $name);
        }

        if (\is_callable(array($this, 'set_' . $name))) {
            return $this->_data[$name] = call_user_func($func, $value);
        }
        return $this->_data[$name] = $value;
    }

    final function __get($name)
    {
        $this->__join();
        $name = strtolower($name);

        if (!in_array($name, $this->_readable)) {
            throw new OutOfRangeException('Cannot get property ' . get_class($this) . '::$' . $name);
        } elseif (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
    }

    protected function __join()
    {
        if (count($this->_accessable) > 0 && $this->_joined == false) {
            $this->_writable = array_merge($this->_writable, $this->_accessable);
            $this->_readable = array_merge($this->_readable, $this->_accessable);
            $this->_joined = true;
        }
    }

    public function all()
    {
        return array_intersect_key($this->_data, array_flip($this->_readable));
    }

    public function set(array $ary = array())
    {
        foreach ($ary as $name => $value) {
            $this->$name = $value;
        }
        return $this->all();
    }
}

