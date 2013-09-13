<?php namespace Bkwld\Library\APIs\Instagram\Commands;

// Dependencies
use Bkwld\Library\APIs\Instagram\OAuth;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AccessToken extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'instagram:access-token';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get the access token for an enviornment.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire() {
		$response = OAuth::exchangeCode($this->argument('code'));
		$this->info('Access token: '.$response->access_token);
		$this->info('User id: '.$response->user->id);
		$this->info('Username: '.$response->user->username);
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			array('code', InputArgument::REQUIRED, 'The code that was returned to the redirect_uri during auth.'),
		);
	}

}