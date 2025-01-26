<?php

namespace App\Entity;

enum OrderStatus: string {
	case NEW = 'new';
	case PENDING = 'pending';
	case FINISHED = 'finished';
}
