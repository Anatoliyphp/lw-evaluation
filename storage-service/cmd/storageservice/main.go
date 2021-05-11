package main

import (
	"context"
	log "github.com/sirupsen/logrus"
	"net/http"
	"os"
	"os/signal"
	"storage-service/cmd/storageservice/config"
	"storage-service/pkg/storageservice/storage"
	"storage-service/pkg/storageservice/transport"
	"syscall"
)

const ErrorProgramExitStatus = 1

func main() {
	log.SetFormatter(&log.JSONFormatter{})
	parsedConfig, err := config.ParseConfig()
	if err != nil {
		log.Error(err)
		os.Exit(ErrorProgramExitStatus)
	}
	fileStorage, err := storage.NewFileStorage(parsedConfig.FileStorageRoot)
	if err != nil {
		log.Error(err)
		os.Exit(ErrorProgramExitStatus)
	}
	srv := startServer(fileStorage, ":8081")
	killSignalChan := getKillSignalChan()
	waitForKillSignal(killSignalChan)
	_ = srv.Shutdown(context.Background())
}

func startServer(storage storage.FileStorage, serverAddress string) *http.Server {
	log.WithFields(log.Fields{
		"server address": serverAddress,
	}).Info("starting the server")
	r := transport.NewRouter(storage)
	srv := &http.Server{Addr: serverAddress, Handler: r}
	go func() {
		log.Fatal(srv.ListenAndServe())
	}()
	return srv
}

func getKillSignalChan() chan os.Signal {
	osKillSignalChan := make(chan os.Signal, 1)
	signal.Notify(osKillSignalChan, os.Kill, os.Interrupt, syscall.SIGTERM)
	return osKillSignalChan
}

func waitForKillSignal(killSignalChan <-chan os.Signal) {
	killSignal := <-killSignalChan
	if killSignal != nil {
		log.Print("got os signal, exiting")
	}
}
