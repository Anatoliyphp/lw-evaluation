export type LabsQueueData = {
  courseName: string;
  groups: Array<GroupData>;
};

type GroupData = {
  groupName: string;
  labs: Array<LabData>;
};

type LabData = {
  labId: string;
  labName: string;
  studentName: string;
  date: Date;
};
