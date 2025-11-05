<?php

declare(strict_types=1);

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Exceptions\ArduinoException;

/**
 * Низкоуровневый драйвер для отправки байтовых команд по последовательному порту Windows.
 * Управляет открытием COM-порта, форматированием команд и корректным завершением работы.
 */
class USBHID implements SystemCodeInterface
{
	/**
	 * Ресурсный дескриптор COM-порта.
	 */
	private $serial;
	
	/**
	 * Настраивает и открывает последовательный порт с заданными параметрами связи.
	 * Выполняет системную команду `mode` для конфигурации порта и регистрирует функцию завершения.
	 *
	 * @param int $com Номер COM-порта (например, 3 для COM3).
	 * @param int $baud Скорость передачи данных в бодах (по умолчанию 9600).
	 * @param string $parity Параметр чётности ('n' — нет, 'e' — чётная, 'o' — нечётная).
	 * @param int $data Количество бит данных (обычно 7 или 8).
	 * @param int $stop Количество стоп-битов (1 или 2).
	 * @param string $to Тайм-аут чтения ('on' или 'off').
	 * @param string $xon Управление потоком XON/XOFF ('on' или 'off').
	 * @param string $odsr Использование DSR для управления передачей ('on' или 'off').
	 * @param string $octs Использование CTS для управления передачей ('on' или 'off').
	 * @param string $dtr Состояние линии DTR при открытии ('on' или 'off').
	 * @param string $rts Состояние линии RTS при открытии ('on' или 'off').
	 * @param string $idsr Игнорирование состояния DSR ('on' или 'off').
	 * @param int $suffix Завершающий байт команды (по умолчанию 0x4D).
	 */
	public function __construct(
		int $com,
		int $baud = 9600,
		string $parity = 'n',
		int $data = 8,
		int $stop = 1,
		string $to = 'off',
		string $xon = 'off',
		string $odsr = 'off',
		string $octs = 'off',
		string $dtr = 'on',
		string $rts = 'on',
		string $idsr = 'off',
		private readonly int $suffix = 0x4D
	) {
		shell_exec("mode com{$com}: baud={$baud} parity={$parity} data={$data} stop={$stop} to={$to} xon={$xon} odsr={$odsr} octs={$octs} dtr={$dtr} rts={$rts} idsr={$idsr}");
		
		$this->serial = fopen('COM' . $com, 'w');
		
		if (is_bool($this->serial)) {
			return;
		}
		
		sleep(2);
		
		register_shutdown_function(function () {
			$this->close();
		});
	}
	
	/**
	 * Формирует и отправляет байтовую команду через последовательный порт.
	 * Команда предваряется преамбулой, завершается суффиксом и ограничена длиной.
	 *
	 * @param array<int, int> $command Массив целочисленных байтов команды (без преамбулы и суффикса).
	 * @param int $microseconds Задержка в микросекундах после отправки.
	 * @throws ArduinoException Если порт недоступен или превышена длина команды.
	 */
	public function send(array $command, int $microseconds = 0): void
	{
		if (!is_resource($this->serial)) {
			throw new ArduinoException('Serial is not resource.');
		}
		
		if ((count($command) - 2) > 5) {
			throw new ArduinoException("The maximum number of arguments should not exceed 5");
		}
		
		$bytes = array_map('chr', [self::PREAMBLE, ...$command]);
		
		if (fwrite($this->serial, implode('', $bytes) . chr($this->suffix)) === false) {
			throw new ArduinoException('Error when sending data: ' . implode(',', $command));
		}
		
		usleep($microseconds);
	}
	
	/**
	 * Закрывает последовательный порт, если он открыт.
	 */
	public function close(): void
	{
		if (is_resource($this->serial)) {
			fclose($this->serial);
		}
	}
	
	/**
	 * Отправляет команду инициализации HID-режима на устройство.
	 */
	public function start(): void
	{
		$this->send(command: [self::BEGIN_HID_COMMAND]);
	}
	
	/**
	 * Отправляет команду завершения HID-режима на устройство.
	 */
	public function stop(): void
	{
		$this->send(command: [self::END_HID_COMMAND]);
	}
	
	/**
	 * Выполняет циклический тест клавиатуры и мыши: отправляет команды начала и окончания теста.
	 * Используется для диагностики работоспособности устройства.
	 */
	public function test(): void
	{
		$i = 0;
		
		while ($i++ < 3) {
			foreach ([
				[USBHID::MOUSE_COMMAND, USBHID::MOUSE_TEST_BEGIN],
				[USBHID::KEYBOARD_COMMAND, USBHID::KEYBOARD_TEST_BEGIN],
				[USBHID::MOUSE_COMMAND, USBHID::MOUSE_TEST_END],
				[USBHID::KEYBOARD_COMMAND, USBHID::KEYBOARD_TEST_END],
			] as $make) {
				$this->send(command: $make);
				sleep(1);
			}
		}
		
		echo 'SUCCESS' . PHP_EOL;
	}
}