<?php #app/commands/CreateUserCommand.php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateUserCommand extends Command {

 /**
  * The console command name.
  *
  * @var string
  */
 protected $name = 'sentry:user';

 /**
  * The console command description.
  *
  * @var string
  */
 protected $description = 'Create a User.';

 /**
  * Create a new command instance.
  *
  * @return void
  */
 public function __construct()
 {
  parent::__construct();
 }

 /**
  * Execute the console command.
  *
  * @return void
  */
 public function fire()
 {
  $email    = $this->ask('Enter the user email');
  $password = $this->secret('Enter the user password');;

  // Create the user
  $user = Sentry::getUserProvider()->create(array(
   'email'    => $email,
   'password' => $password,
   ));

  $this->info('User created!');

  // Active user
  if ($user->attemptActivation(null))
  {
          // User activation passed
          $this->info('User activation passed!');
  }
  else
  {
          // User activation failed
          $this->info('User activation failed!');
  }

  $groupName = $this->ask('Enter the user group');

  // Find the group using the group id
  $adminGroup = Sentry::getGroupProvider()->findByName($groupName);

  // Assign the group to the user
  $user->addGroup($adminGroup);

  $this->info("The {$groupName} group was assigned to the user!");
 }

}