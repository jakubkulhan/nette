<?php
require __DIR__ . '/TestCase.php';

function quit($msg)
{
	fprintf(STDERR, "worker(%d): %s\n", getmypid(), $msg);
	die(1);
}

for (;;) {
	if (($changed = stream_select($r = array(STDIN), $w = NULL, $e = NULL, NULL)) === FALSE) {
		quit('stream_select() failed');
	}

	if (strlen($data = fread(STDIN, 4)) !== 4) {
		if (strlen($data) === 0 && feof(STDIN)) {
			return 0;
		}

		quit('fread(1) failed');
	}

	list(,$n) = unpack('N', $data);

	if (strlen($data = fread(STDIN, $n)) !== $n) {
		quit('fread(2) failed');
	}

	$msg = unserialize($data);
	$response = NULL;

	if ($msg instanceof TestCase) {
		try {
			$msg->run();
			$response = $msg;
		} catch (Exception $e) {
			$response = $e;
		}

	} else {
		quit('Unknown message');
	}

	$serialized = serialize($response);
	$data = pack('N', strlen($serialized)) . $serialized;

	if (fwrite(STDOUT, $data) !== strlen($data)) {
		quit('fwrite() failed.');
	}
}
