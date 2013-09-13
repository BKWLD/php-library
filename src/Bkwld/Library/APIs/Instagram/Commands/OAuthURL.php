<?php namespace Bkwld\Library\APIs\Instagram\Commands;

// Dependencies
use Bkwld\Library\APIs\Instagram\OAuth;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class OAuthURL extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'instagram:oauth-url';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Return the OAuth URL for the enviornment.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire() {
		$this->info(OAuth::url());
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			array('env', InputArgument::OPTIONAL, 'Specify an enviornment other than the current one.'),
		);
	}

}