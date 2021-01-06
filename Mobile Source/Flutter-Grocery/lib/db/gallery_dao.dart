import 'package:fluttermultigrocery/viewobject/default_photo.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';

class GalleryDao extends PsDao<DefaultPhoto> {
  GalleryDao._() {
    init(DefaultPhoto());
  }

  static const String STORE_NAME = 'Gallery';
  final String _primaryKey = 'id';
  // Singleton instance
  static final GalleryDao _singleton = GalleryDao._();

  // Singleton accessor
  static GalleryDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(DefaultPhoto object) {
    return object.imgId;
  }

  @override
  Filter getFilter(DefaultPhoto object) {
    return Filter.equals(_primaryKey, object.imgId);
  }
}
