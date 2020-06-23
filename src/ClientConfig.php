<?php
namespace ArbitrageGoogleSheet;

class ClientConfig
{
	private string $_tokenPath = __DIR__.'/../../var/token.json';
	private string $_credentialsPath = __DIR__.'/../../var/credentials.json';
	private string $_applicationName = 'Arbitrage Google Sheet';
	private string $_scope;
	private string $_accessType = 'offline';
	private string $_prompt = 'select_account consent';

	public function getTokenPath(): string
	{
		return $this->_tokenPath;
	}

	public function setTokenPath(string $tokenPath): self
	{
		$this->_tokenPath = $tokenPath;
		return $this;
	}

	public function getCredentialsPath(): string
	{
		return $this->_credentialsPath;
	}

	public function setCredentialsPath(string $credentialsPath): self
	{
		$this->_credentialsPath = $credentialsPath;
		return $this;
	}

	public function getApplicationName(): string
	{
		return $this->_applicationName;
	}

	public function setApplicationName(string $applicationName): self
	{
		$this->_applicationName = $applicationName;
		return $this;
	}

	public function getScope(): string
	{
		return $this->_scope;
	}

	public function setScope(string $scope): self
	{
		$this->_scope = $scope;
		return $this;
	}

	public function getAccessType(): string
	{
		return $this->_accessType;
	}

	public function setAccessType(string $accessType): self
	{
		$this->_accessType = $accessType;
		return $this;
	}

	public function getPrompt(): string
	{
		return $this->_prompt;
	}

	public function setPrompt(string $prompt): self
	{
		$this->_prompt = $prompt;
		return $this;
	}
}