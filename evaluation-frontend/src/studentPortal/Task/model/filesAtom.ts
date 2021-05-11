import { declareAction, declareAtom } from '@reatom/core';
import { FileData } from './FileData';

const addFileAction = declareAction<FileData>();
const deleteFileAction = declareAction<string>();
const setFilesAction = declareAction<Array<FileData>>();

function generateFileId(file: File): string {
  return Math.random() + file.name;
}

const filesAtom = declareAtom<Array<FileData>>([], (on) => [
  on(setFilesAction, (_, files) => [...files]),
  on(addFileAction, (state, file) => [...state, file]),
  on(deleteFileAction, (state, fileName) =>
    [...state].filter((f) => f.name !== fileName)
  ),
]);

export { addFileAction, deleteFileAction, setFilesAction, filesAtom };
