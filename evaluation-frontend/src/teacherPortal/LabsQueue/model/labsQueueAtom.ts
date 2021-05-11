import { declareAtom } from '@reatom/core';
import { LabsQueueData } from './LabsQueueData';

const mockLabsQueueData: Array<LabsQueueData> = [
  {
    courseName: 'Основы программирования',
    groups: [
      {
        groupName: 'ПС-11',
        labs: [
          {
            labId: '1',
            labName: 'Программа BubbleSort',
            studentName: 'Кузнечиков А.А.',
            date: new Date(2021, 2, 3, 19),
          },
          {
            labId: '2',
            labName: 'Программа BubbleSort',
            studentName: 'Ипсов Е.А.',
            date: new Date(2021, 2, 3),
          },
        ],
      },
      {
        groupName: 'ПС-21',
        labs: [
          {
            labId: '1',
            labName: 'Программа BubbleSort',
            studentName: 'Кузнечиков А.А.',
            date: new Date(2021, 2, 3),
          },
          {
            labId: '2',
            labName: 'Программа BubbleSort',
            studentName: 'Ипсов Е.А.',
            date: new Date(2021, 2, 3),
          },
        ],
      },
    ],
  },
  {
    courseName: 'Введение в специальность',
    groups: [
      {
        groupName: 'ПС-11',
        labs: [
          {
            labId: '1',
            labName: 'Программа BubbleSort',
            studentName: 'Кузнечиков А.А.',
            date: new Date(2021, 1, 2),
          },
          {
            labId: '2',
            labName: 'Программа BubbleSort',
            studentName: 'Ипсов Е.А.',
            date: new Date(2021, 2, 3, 10),
          },
        ],
      },
      {
        groupName: 'ПС-21',
        labs: [
          {
            labId: '1',
            labName: 'Программа BubbleSort',
            studentName: 'Кузнечиков А.А.',
            date: new Date(2021, 2, 3, 19, 35),
          },
          {
            labId: '2',
            labName: 'Программа BubbleSort',
            studentName: 'Ипсов Е.А.',
            date: new Date(2021, 1, 2),
          },
        ],
      },
    ],
  },
];

const labsQueueAtom = declareAtom<Array<LabsQueueData>>(
  mockLabsQueueData,
  () => []
);

export { labsQueueAtom };
