<?php

error_reporting( E_ALL | E_STRICT );
define( 'ITERATIONS', 1000000 );

// Output a result item in the table
function log_result( $title, $start, $stop ) {
	$diff = ($stop - $start);
	echo '<tr><th>' . $title . '</th><td>' . round( $diff, 4 ) . ' sec<td>' . round( ($diff * 1000000) / ITERATIONS, 4 ) . ' μs</tr>';
}

echo '<doctype html><html><head><meta charset="utf-8"></head><body>';
echo 'PHP Version: ' . phpversion() . '<br>';
echo 'Iterations: ' . number_format( ITERATIONS ) . '<br>';
echo '<table border="1" cellpadding="5" cellspacing="0">';
echo '<tr><th>Test<th>Total Time<th>Single call</tr>';

// Test class for get/set tests.
class TestGetSet {
	public $full_access = 'full';
	private $read_only = 'read-only';

	public function __get( $var ) {
		return $this->$var;
	}
	public function __set( $var, $val ) {
		return;
	}
}
$test = new TestGetSet();

// - - - - - - - - - - - -
$start = microtime( true );
for ( $i = 0; $i < ITERATIONS; $i += 1 ) {
	$val = $test->full_access;
}
$stop = microtime( true );
log_result( 'Native, get', $start, $stop );

// - - - - - - - - - - - -
$start = microtime( true );
for ( $i = 0; $i < ITERATIONS; $i += 1 ) {
	$val = $test->read_only;
}
$stop = microtime( true );
log_result( 'Read only, get', $start, $stop );

// - - - - - - - - - - - -
$start = microtime( true );
for ( $i = 0; $i < ITERATIONS; $i += 1 ) {
	$test->full_access = 'test';
}
$stop = microtime( true );
log_result( 'Native, set', $start, $stop );

// - - - - - - - - - - - -
$start = microtime( true );
for ( $i = 0; $i < ITERATIONS; $i += 1 ) {
	$test->read_only = 'test';
}
$stop = microtime( true );
log_result( 'Read only, set', $start, $stop );
