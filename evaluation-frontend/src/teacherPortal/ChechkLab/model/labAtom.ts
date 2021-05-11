import { declareAtom } from '@reatom/core';
import { LabData } from './LabData';

const parts = [
  new Blob(['you construct a file...'], { type: 'text/plain' }),
  ' Same way as you do with blob',
  new Uint16Array([33]),
];

const mockLabData: LabData = {
  studentId: '1',
  maxScore: 20,
  labId: '1',
  title: '1',
  tasks: [
    {
      taskId: '1',
      files: [new File(parts, 'task1.png')],
      score: 10,
      autoEvaluation: true,
      compiled: true,
    },
    {
      taskId: '2',
      files: [new File(parts, 'task2.png')],
      score: 5,
      autoEvaluation: false,
      compiled: false,
    },
  ],
};
const labAtom = declareAtom<LabData>(mockLabData, () => []);

export { labAtom };
