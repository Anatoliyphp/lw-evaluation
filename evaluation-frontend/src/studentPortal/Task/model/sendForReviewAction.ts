import { sendTaskForReview } from '../../../api/taskCompletionApi';
import { declareAction } from '@reatom/core';
import { FileData } from './FileData';

const sendForReviewAction = declareAction<Array<FileData>>(
  (payload, { dispatch }) => {
    sendTaskForReview(payload).then((response) => {
      console.log('Мы проверяемся');
      if (response.status === 200) {
        // success
      }
    });
  }
);

export { sendForReviewAction };
