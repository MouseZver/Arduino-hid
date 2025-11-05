<?php

declare(strict_types=1);

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Enums\MouseCode;

/**
 * Класс управления мышью через HID-устройство на базе Arduino.
 * Поддерживает перемещение курсора и имитацию нажатий кнопок.
 */
class Mouse extends Arduino implements SystemCodeInterface
{
	/**
	 * Перемещает курсор мыши на заданное смещение по осям X и Y.
	 * Значения ограничены диапазоном [-128, 127] и преобразуются в беззнаковый байт.
	 *
	 * @param int $x Смещение по горизонтали (отрицательное — влево, положительное — вправо).
	 * @param int $y Смещение по вертикали (отрицательное — вверх, положительное — вниз).
	 */
	public function move(int $x, int $y): void
	{
		$x = max(-128, min(127, $x)) & 0xFF;
		$y = max(-128, min(127, $y)) & 0xFF;
		
		$this->hid->send(
			command: [self::MOUSE_COMMAND, self::MOUSE_MOVE, $x, $y],
			microseconds: $this->microseconds
		);
	}
	
	/**
	 * Выполняет кратковременное нажатие и отпускание указанной кнопки мыши.
	 *
	 * @param MouseCode $enum Код кнопки мыши (левая, правая, колёсико и т.д.).
	 */
	public function click(MouseCode $enum): void
	{
		$this->send(input: [$enum], device: self::MOUSE_COMMAND, command: self::MOUSE_CLICK);
	}
	
	/**
	 * Удерживает указанную кнопку мыши в нажатом состоянии.
	 *
	 * @param MouseCode $enum Код кнопки мыши для удержания.
	 */
	public function press(MouseCode $enum): void
	{
		$this->send(input: [$enum], device: self::MOUSE_COMMAND, command: self::MOUSE_PRESS);
	}
	
	/**
	 * Отпускает все удерживаемые кнопки мыши.
	 */
	public function releaseAll(): void
	{
		$this->send(input: [], device: self::MOUSE_COMMAND, command: self::MOUSE_RELEASE_ALL);
	}
}