import { declareAtom, declareAction } from '@reatom/core';
import { LabData } from './ApiLabListItemData';

const setLabListAction = declareAction<GetLabListResponseData>();

type GetLabListResponseData = {
  courseTitle: string;
  courseDescription: string;
  labList: LabData[];
};

const labsAtom = declareAtom<GetLabListResponseData | null>(null, (on) => [
  on(setLabListAction, (_, labList) => labList),
]);

export { setLabListAction, labsAtom };
