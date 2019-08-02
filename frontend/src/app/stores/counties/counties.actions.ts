export class CountiesLoadAction {
  public static readonly type = '[Counties] Load items';

  constructor(public stateId: number) {
  }
}

export class CountiesResetAction {
  public static readonly type = '[Counties] Reset';
}
