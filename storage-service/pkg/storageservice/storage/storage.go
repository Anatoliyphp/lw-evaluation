package storage

import (
	"errors"
	"io"
	"io/ioutil"
	"os"
	"path/filepath"
	"strings"
)

var FileNotExists = errors.New("file not exists")
var FileAlreadyExists = errors.New("file already exists")

type File struct {
	Path    string
	Content io.ReadCloser
}

type FileStorage interface {
	Get(path string) (io.ReadCloser, error)
	Save(file File) error
	Delete(path string) error
}

type storage struct {
	rootFolder string
}

func (s *storage) Get(path string) (io.ReadCloser, error) {
	filePath := strings.TrimSpace(filepath.Join(s.rootFolder, path))
	file, err := os.OpenFile(filePath, os.O_RDONLY, 0666)
	if os.IsNotExist(err) {
		return nil, FileNotExists
	} else if err != nil {
		return nil, err
	}
	return file, nil
}

func (s *storage) Save(file File) error {
	path := strings.TrimSpace(filepath.Join(s.rootFolder, file.Path))
	defer func() {
		_ = file.Content.Close()
	}()
	err := os.MkdirAll(filepath.Dir(path), 0666)
	if err != nil {
		return err
	}
	createdFile, err := os.OpenFile(path, os.O_CREATE|os.O_EXCL, 0666)
	if os.IsExist(err) {
		return FileAlreadyExists
	} else if err != nil {
		return err
	}
	defer func() {
		_ = createdFile.Close()
	}()
	fileBytes, err := ioutil.ReadAll(file.Content)
	if err != nil {
		return err
	}
	_, err = createdFile.Write(fileBytes)
	if err != nil {
		return err
	}
	return nil
}

func (s *storage) Delete(path string) error {
	file, err := os.OpenFile(filepath.Join(s.rootFolder, path), os.O_RDWR, 0666)
	if os.IsNotExist(err) {
		return FileNotExists
	} else if err != nil {
		return err
	}
	err = file.Close()
	if err != nil {
		return err
	}
	err = os.Remove(filepath.Join(s.rootFolder, path))
	if err != nil {
		return err
	}
	return nil
}

func NewFileStorage(rootFolder string) (FileStorage, error) {
	err := os.MkdirAll(rootFolder, 0666)
	if err != nil {
		return nil, err
	} else {
		return &storage{rootFolder}, nil
	}
}
