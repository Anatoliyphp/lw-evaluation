import { useAction, useAtom } from '@reatom/react';
import { useEffect } from 'react';
import { useParams } from 'react-router';
import { fetchSpinnerVisibilityAtom } from '../../../common/Spinner/model/fetchSpinnerAtom';
import { Spinner } from '../../../common/Spinner/view/Spinner';
import { getLabListAction } from '../model/getLabListAction';
import { labsAtom } from '../model/labsAtom';

import classes from './LabList.module.css';
import { LabWork } from './LabWork/LabWork';

function LabList() {
  const labs = useAtom(labsAtom);
  const spinner = useAtom(fetchSpinnerVisibilityAtom);

  const params: { courseId: string } = useParams();

  const getLabList = useAction(getLabListAction);

  useEffect(() => {
    getLabList(params.courseId);
  }, [getLabList, params.courseId]);

  const labViews = labs?.labList.map((lab) => (
    <LabWork
      key={lab.id}
      id={lab.id}
      name={lab.name}
      maxScore={lab.maxScore}
      description={lab.description}
      isAvailable={lab.isAvailable}
      recievedScore={lab.recievedScore}
    />
  ));

  return (
    <div className={classes.LabList}>
      <h2 className={classes.CourseTitle}>{labs?.courseTitle}</h2>
      <p className={classes.CourseDescription}>{labs?.courseDescription}</p>
      <div className={classes.LabWorks}>
        {spinner ? <Spinner type='fetch' /> : labViews}
      </div>
    </div>
  );
}

export { LabList };
