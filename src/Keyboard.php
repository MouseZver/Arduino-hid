<?php

declare(strict_types=1);

namespace Nouvu\ArduinoHID;

use Nouvu\ArduinoHID\Enums\{ KeyboardCode, KeyboardMediaCode, KeyboardSystemCode };

/**
 * Класс управления клавиатурой через HID-устройство на базе Arduino.
 * Поддерживает отправку обычных клавиш, мультимедийных и системных кодов.
 */
class Keyboard extends Arduino implements SystemCodeInterface
{
	/**
	 * Выполняет кратковременное нажатие и отпускание указанных клавиш.
	 *
	 * @param KeyboardCode ...$enums Перечисление клавиш для имитации нажатия.
	 */
	public function click(KeyboardCode ...$enums): void
	{
		$this->send(input: $enums, device: self::KEYBOARD_COMMAND, command: self::KEYBOARD_CLICK);
	}
	
	/**
	 * Удерживает указанные клавиши в нажатом состоянии.
	 *
	 * @param KeyboardCode ...$enums Перечисление клавиш для удержания.
	 */
	public function press(KeyboardCode ...$enums): void
	{
		$this->send(input: $enums, device: self::KEYBOARD_COMMAND, command: self::KEYBOARD_PRESS);
	}
	
	/**
	 * Отпускает ранее нажатые клавиши.
	 *
	 * @param KeyboardCode ...$enums Перечисление клавиш для отпускания.
	 */
	public function release(KeyboardCode ...$enums): void
	{
		$this->send(input: $enums, device: self::KEYBOARD_COMMAND, command: self::KEYBOARD_RELEASE);
	}
	
	/**
	 * Отпускает все удерживаемые клавиши без указания конкретных кодов.
	 */
	public function releaseAll(): void
	{
		$this->send(input: [], device: self::KEYBOARD_COMMAND, command: self::KEYBOARD_RELEASE_ALL);
	}
	
	/**
	 * Выполняет однократное нажатие мультимедийной клавиши.
	 *
	 * @param KeyboardMediaCode $enum Код мультимедийной функции (громкость, воспроизведение и т.д.).
	 */
	public function clickMedia(KeyboardMediaCode $enum): void
	{
		$this->send(input: [$enum], device: self::KEYBOARD_COMMAND, command: self::KEYBOARD_MEDIA_KEY);
	}
	
	/**
	 * Выполняет однократное нажатие системной клавиши.
	 *
	 * @param KeyboardSystemCode $enum Код системной функции (питание, сон, пробуждение и т.д.).
	 */
	public function clickSystem(KeyboardSystemCode $enum): void
	{
		$this->send(input: [$enum], device: self::KEYBOARD_COMMAND, command: self::KEYBOARD_SYSTEM_KEY);
	}
}