FROM golang:1.16.0 as build
WORKDIR /storage-service
COPY . .
RUN go mod tidy
RUN CGO_ENABLED=0 go build ./cmd/storageservice/main.go

FROM scratch
COPY --from=build storage-service/main .
EXPOSE 8081
ENTRYPOINT ["./main"]