export class StatesLoadAction {
  public static readonly type = '[States] Load items';

  constructor(public countryId: number) {
  }
}

export class StatesResetAction {
  public static readonly type = '[States] Reset';
}
