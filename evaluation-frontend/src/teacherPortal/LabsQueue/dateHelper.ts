function getDaysDelay(days: number): string {
  if (days >= 1 && days < 31) {
    const lastFigure = parseInt(days.toString()[days.toString().length - 1]);
    if (lastFigure === 1) return `${days} день назад`;
    if (lastFigure >= 2 && lastFigure <= 24 && days < 5 && days > 21)
      return `${days} дня назад`;
    return `${days} дней назад`;
  }
  return '';
}

function getHoursDelay(hours: number): string {
  if (hours >= 1 && hours < 24) {
    const lastFigure = parseInt(hours.toString()[hours.toString().length - 1]);
    if (lastFigure === 1) return `${hours} час назад`;
    if (lastFigure >= 2 && lastFigure <= 4) return `${hours} часа назад`;
    if (hours >= 5 && hours <= 20) return `${hours} часов назад`;
  }
  return '';
}

function getMinutesDelay(minutes: number): string {
  if (minutes >= 1 && minutes < 60) {
    const lastFigure = parseInt(
      minutes.toString()[minutes.toString().length - 1]
    );
    if (lastFigure === 1 && minutes !== 11) return `${minutes} минуту назад`;
    if (lastFigure >= 2 && lastFigure <= 4) return `${minutes} минуты назад`;
    if (lastFigure >= 5 || lastFigure === 0 || minutes === 11)
      return `${minutes} минут назад`;
  }
  return '';
}

function getSecondsDelay(seconds: number): string {
  if (seconds >= 1 && seconds < 60) {
    const lastFigure = parseInt(
      seconds.toString()[seconds.toString().length - 1]
    );
    if (lastFigure === 1 && seconds !== 11) return `${seconds} секунду назад`;
    if (lastFigure >= 2 && lastFigure <= 4) return `${seconds} секунды назад`;
    if (lastFigure >= 5 || lastFigure === 0 || seconds === 11)
      return `${seconds} секунд назад`;
  }
  return '';
}

function parseDateDifference(date: Date): string {
  const seconds = Math.floor((Date.now() - date.getTime()) / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);

  if (days > 1 && days < 31) return getDaysDelay(days);
  if (hours > 1 && hours < 24) return getHoursDelay(hours);
  if (minutes > 1 && minutes < 60) return getMinutesDelay(minutes);
  if (seconds > 1 && seconds < 60) return getSecondsDelay(seconds);
  if (seconds === 0) return 'Только что';

  const day = date.getDay();
  const month = date.getMonth();
  const year = date.getFullYear();

  const dayStr = day < 10 ? '0' + day : day.toString();
  const monthStr = month < 10 ? '0' + month : month.toString();

  return `${dayStr}.${monthStr}.${year}`;
}

export { parseDateDifference };
