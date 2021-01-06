import 'package:fluttermultigrocery/viewobject/comment_detail.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class CommentDetailDao extends PsDao<CommentDetail> {
  CommentDetailDao._() {
    init(CommentDetail());
  }
  static const String STORE_NAME = 'CommentDetail';
  final String _primaryKey = 'id';

  // Singleton instance
  static final CommentDetailDao _singleton = CommentDetailDao._();

  // Singleton accessor
  static CommentDetailDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(CommentDetail object) {
    return object.id;
  }

  @override
  Filter getFilter(CommentDetail object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
