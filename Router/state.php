<?php

use app\State\StartState;
use natilosir\bot\State;

State::add('phoneNumber', [ StartState::class, 'phoneNumber' ]);