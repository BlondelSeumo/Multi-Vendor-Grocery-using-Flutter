import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class AppInfoParameterHolder extends PsHolder<AppInfoParameterHolder> {
  AppInfoParameterHolder(
      {@required this.startDate,
      @required this.endDate,
      @required this.userId});

  final String startDate;
  final String endDate;
  final String userId;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['start_date'] = startDate;
    map['end_date'] = endDate;
    map['user_id'] = userId;

    return map;
  }

  @override
  AppInfoParameterHolder fromMap(dynamic dynamicData) {
    return AppInfoParameterHolder(
      startDate: dynamicData['start_date'],
      endDate: dynamicData['end_date'],
      userId: dynamicData['user_id'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (startDate != '') {
      key += startDate;
    }
    if (endDate != '') {
      key += endDate;
    }
    if (userId != '') {
      key += userId;
    }
    return key;
  }
}
