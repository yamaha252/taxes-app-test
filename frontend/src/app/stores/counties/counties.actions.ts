export class CountiesLoadAction {
  public static readonly type = '[Counties] Load items';

  constructor(public stateId: number) {
  }
}

export class CountiesCleanAction {
  public static readonly type = '[Counties] Clean items';
}
