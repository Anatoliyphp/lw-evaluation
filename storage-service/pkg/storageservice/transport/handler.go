package transport

import (
	"io"
	"net/http"
	"path/filepath"
	"storage-service/pkg/storageservice/storage"

	"github.com/gorilla/mux"
	log "github.com/sirupsen/logrus"
	"github.com/urfave/negroni"
)

func getAddHandler(fileStorage storage.FileStorage) func(res http.ResponseWriter, req *http.Request) {
	return func(res http.ResponseWriter, req *http.Request) {
		src := req.Body
		if req.URL.Path == "/" {
			http.Error(res, "incorrect request", http.StatusBadRequest)
			return
		}
		file := storage.File{Path: req.URL.Path, Content: src}
		err := fileStorage.Save(file)
		switch err {
		case nil:
			res.WriteHeader(http.StatusNoContent)
		case storage.FileAlreadyExists:
			http.Error(res, err.Error(), http.StatusConflict)
		default:
			http.Error(res, err.Error(), http.StatusInternalServerError)
		}
	}
}

func getGetHandler(fileStorage storage.FileStorage) func(res http.ResponseWriter, req *http.Request) {
	return func(res http.ResponseWriter, req *http.Request) {
		filePath := req.URL.Path
		if filePath == "/" {
			http.Error(res, "incorrect request", http.StatusBadRequest)
			return
		}
		file, err := fileStorage.Get(filePath)
		if err != nil {
			if err == storage.FileNotExists {
				http.Error(res, err.Error(), http.StatusNotFound)
				return
			} else {
				http.Error(res, err.Error(), http.StatusInternalServerError)
				return
			}
		}
		res.Header().Set("Content-Disposition", "attachment; filename="+filepath.Base(req.URL.Path))
		res.Header().Set("Content-Type", "application/octet-stream")

		_, err = io.Copy(res, file)
		defer func() {
			_ = file.Close()
		}()
		if err != nil {
			http.Error(res, err.Error(), http.StatusInternalServerError)
		}
	}
}

func getDeleteHandler(fileStorage storage.FileStorage) func(res http.ResponseWriter, req *http.Request) {
	return func(res http.ResponseWriter, req *http.Request) {
		filePath := req.URL.Path
		if filePath == "/" {
			http.Error(res, "incorrect request", http.StatusBadRequest)
			return
		}
		err := fileStorage.Delete(filePath)
		switch err {
		case nil:
			res.WriteHeader(http.StatusNoContent)
		case storage.FileNotExists:
			http.Error(res, err.Error(), http.StatusNotFound)
		default:
			http.Error(res, err.Error(), http.StatusInternalServerError)
		}
	}
}

func NewRouter(storage storage.FileStorage) http.Handler {
	r := mux.NewRouter()
	r.PathPrefix("/").HandlerFunc(getDeleteHandler(storage)).Methods(http.MethodDelete)
	r.PathPrefix("/").HandlerFunc(getAddHandler(storage)).Methods(http.MethodPost)
	r.PathPrefix("/").HandlerFunc(getGetHandler(storage)).Methods(http.MethodGet)
	return logMiddleware(r)
}

func logMiddleware(h http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		lrw := negroni.NewResponseWriter(w)
		h.ServeHTTP(lrw, r)
		log.WithFields(log.Fields{
			"method": r.Method,
			"status": lrw.Status(),
			"url":    r.URL.Path,
		}).Info("handled request")
	})
}
