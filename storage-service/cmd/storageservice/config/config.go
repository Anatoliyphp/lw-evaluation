package config

import (
	"errors"
	"os"
)

type Config struct {
	FileStorageRoot string
}

const fileStorageRootEnvName = "FILESTORAGE_ROOT"

func ParseConfig() (Config, error) {
	rootFolder, exists := os.LookupEnv(fileStorageRootEnvName)
	if exists {
		return Config{FileStorageRoot: rootFolder}, nil
	} else {
		return Config{}, errors.New("can't parse variable: " + fileStorageRootEnvName)
	}
}
