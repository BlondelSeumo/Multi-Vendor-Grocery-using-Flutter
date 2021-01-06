import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';

class ApiStatus extends PsObject<ApiStatus> {
  ApiStatus({
    this.status,
    this.message,
  });

  String status;
  String message;

  @override
  bool operator ==(dynamic other) =>
      other is ApiStatus && status == other.status;

  @override
  int get hashCode => hash2(status.hashCode, status.hashCode);

  @override
  String getPrimaryKey() {
    return status;
  }

  @override
  List<ApiStatus> fromMapList(List<dynamic> dynamicDataList) {
    final List<ApiStatus> subCategoryList = <ApiStatus>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          subCategoryList.add(fromMap(dynamicData));
        }
      }
    }
    return subCategoryList;
  }

  @override
  ApiStatus fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return ApiStatus(
        status: dynamicData['status'],
        message: dynamicData['message'],
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(ApiStatus object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['status'] = object.status;
      data['message'] = object.message;

      return data;
    } else {
      return null;
    }
  }

  @override
  List<Map<String, dynamic>> toMapList(List<ApiStatus> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (ApiStatus data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }
    return mapList;
  }
}
