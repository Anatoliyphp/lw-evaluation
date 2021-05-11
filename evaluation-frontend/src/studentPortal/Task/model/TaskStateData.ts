type TaskStateData = {
  lastActionId: string;
  actions: Array<ActionData>;
};

type ActionData = {
  index: number;
  id: number;
  type: number;
  state: number;
  files: Array<FileData>;
};

type FileData = {
  name: string;
  downloadUrl: string;
};

enum ActionType {
  FILE_UPLOAD = 1,
  PASCAL_COMPILATION,
  TEACHER_EVALUATION,
}

enum ActionState {
  IN_PROGRESS = 1,
  COMPLETED,
  ERROR,
}

export type { TaskStateData, ActionData };
export { ActionType, ActionState };
