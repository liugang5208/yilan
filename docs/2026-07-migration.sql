-- ============================================================
-- 7月数据库变更 SQL
-- 项目：yilan / 分支：feature/20260531-price-auto-update
-- 整理日期：2026-07-03
-- ============================================================


-- ============================================================
-- 一、任务队列清理（服务器部署前执行）
-- ============================================================

-- 1. 清理僵死任务：status=1 但无 pending task_log 的 task 标记为完成
--    （这类任务永远排在队头，阻塞后续任务消费）
UPDATE task
SET status = 3, ratio = 100, up_time = UNIX_TIMESTAMP()
WHERE status IN (1, 2)
  AND type = 1
  AND (
    SELECT COUNT(*) FROM task_log
    WHERE task_id = task.id AND status IN (1, 2)
  ) = 0;

-- 2. 清理所有待开始和处理中的 task_log（按需执行，彻底重置队列）
UPDATE task_log SET status = 4 WHERE status IN (1, 2);

-- 3. 将关联的 task 也标记为作废
UPDATE task SET status = 4 WHERE type = 1 AND status IN (1, 2);

-- 4. 重置卡住超过 2 小时的 status=2（处理中）task_log 为待处理
--    （定期维护，防止任务卡死）
UPDATE task_log
SET status = 1, hand_time = NULL
WHERE status = 2
  AND hand_time < UNIX_TIMESTAMP() - 7200;


-- ============================================================
-- 二、new_cate 表字段修复（NOT NULL 字段缺少默认值导致 INSERT 报错）
-- ============================================================

-- 修复：alias_name、name、add_time、up_time 无默认值，添加后报错
-- SQLSTATE[HY000]: Field 'xxx' doesn't have a default value
ALTER TABLE new_cate
  MODIFY alias_name varchar(50)  NOT NULL DEFAULT '',
  MODIFY name       varchar(100) NOT NULL DEFAULT '',
  MODIFY add_time   int          NOT NULL DEFAULT 0,
  MODIFY up_time    int          NOT NULL DEFAULT 0;
