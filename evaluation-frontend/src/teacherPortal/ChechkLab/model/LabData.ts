export type LabData = {
  studentId: string;
  labId: string;
  title: string;
  maxScore: number;
  tasks: Array<TaskData>;
};

type TaskData = {
  taskId: string;
  autoEvaluation: boolean;
  compiled: boolean;
  score: number;
  files: Array<File>;
};
