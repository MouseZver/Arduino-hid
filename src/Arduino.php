<?php

declare(strict_types=1);

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Enums\{ KeyboardCode, KeyboardMediaCode, KeyboardSystemCode, MouseCode };

/**
 * Базовый класс для взаимодействия с HID-устройством через Arduino.
 * Предоставляет обобщённый метод отправки команд и управление задержкой между командами.
 */
class Arduino
{
	/**
	 * Значение задержки в микросекундах между отправкой команд.
	 */
	protected int $microseconds = 0;
	
	/**
	 * Инициализирует экземпляр с интерфейсом низкоуровневой передачи данных.
	 *
	 * @param USBHID $hid Экземпляр драйвера для отправки байтовых команд по последовательному порту.
	 */
	public function __construct(
		protected USBHID $hid
	) {}
	
	/**
	 * Устанавливает задержку в микросекундах между последовательными командами.
	 *
	 * @param int $microseconds Значение задержки в микросекундах.
	 */
	public function setMicroseconds(int $microseconds): void
	{
		$this->microseconds = $microseconds;
	}
	
	/**
	 * Преобразует перечисления в байтовые значения и отправляет их через HID-драйвер.
	 *
	 * @param array<int, KeyboardCode|KeyboardMediaCode|KeyboardSystemCode|MouseCode> $input Массив перечислений для отправки.
	 * @param int $device Идентификатор устройства (например, клавиатура или мышь).
	 * @param int $command Код операции (например, нажатие, отпускание, перемещение).
	 */
	protected function send(array $input, int $device, int $command): void
	{
		$keys = array_map(
			fn(KeyboardCode|KeyboardMediaCode|KeyboardSystemCode|MouseCode $e) => $e->value,
			$input
		);
		
		$this->hid->send(
			command: [$device, $command, ...$keys],
			microseconds: $this->microseconds
		);
	}
}