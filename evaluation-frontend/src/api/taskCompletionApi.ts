import { FileData } from '../studentPortal/Task/model/FileData';

function sendTaskForReview(files: Array<FileData>): Promise<any> {
  const promise = new Promise((resolve, reject) => {
    setTimeout(() => {
      resolve({
        status: 200,
      });
    }, 1000);
  });

  return promise;
}

export { sendTaskForReview };
