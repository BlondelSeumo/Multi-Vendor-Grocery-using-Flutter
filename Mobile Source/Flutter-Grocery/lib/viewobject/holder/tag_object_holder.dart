import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class TagParameterHolder extends PsHolder<TagParameterHolder> {
  TagParameterHolder(
      {@required this.fieldName, @required this.tagId, @required this.tagName});

  final String fieldName;
  final String tagId;
  final String tagName;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['field_name'] = fieldName;
    map['tag_id'] = tagId;
    map['tag_name'] = tagName;

    return map;
  }

  @override
  TagParameterHolder fromMap(dynamic dynamicData) {
    return TagParameterHolder(
      fieldName: dynamicData['field_name'],
      tagId: dynamicData['tag_id'],
      tagName: dynamicData['tag_name'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (fieldName != '') {
      key += fieldName;
    }
    if (tagId != '') {
      key += tagId;
    }

    if (tagName != '') {
      key += tagName;
    }
    return key;
  }
}
